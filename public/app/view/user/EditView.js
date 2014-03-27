/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

Ext.define('AccountManager.view.user.EditView', {
    extend: 'Ext.window.Window',
    alias: 'widget.usereditview',

    constrain: true,
    hideMode: 'offsets',
    closeAction: 'hide',
    resizable: false,
    title: '',
    width: 400,
    height: 210,
    modal: true,

    initComponent: function() {
        var me = this;

        me.form = Ext.create('Ext.form.Panel', {
            border: false,
            bodyPadding: 5,
            bodyStyle: 'background:#DFE9F6',
            trackResetOnLoad: true,
            waitTitle: '请等待...',
            api: {
                submit: AccountManager.Direct.User.add
            },
            fieldDefaults: {
                labelWidth: 50,
                labelSeparator: ':',
                anchor: '0'
            },
            items: [
                {
                    xtype: 'textfield',
                    fieldLabel: 'ID',
                    name: 'UserId',
                    readOnly: true,
                    readOnlyCls: 'x-item-disabled'
                },
                {
                    xtype: 'textfield',
                    fieldLabel: '用户名',
                    name: 'Name',
                    allowBlank: false,
                    maxLength: 25
                },
                {
                    xtype: 'textfield',
                    fieldLabel: '昵称',
                    name: 'NickName',
                    allowBlank: false,
                    maxlength: 25
                },
                {
                    xtype: 'combobox',
                    name: 'RoleId',
                    fieldLabel: '角色',
                    valueField: 'RoleId',
                    displayField: 'RoleName',
                    store: 'RoleCombo',
                    forceSelection: true,
                    queryMode: 'local',
                    allowBlank: false,
                    minChars: 1
                },
                {
                    xtype: 'textfield',
                    inputType:"password",
                    fieldLabel: '密码',
                    name: 'Password',
                    allowBlank: true,
                    maxLength: 32
                }
            ],

            dockedItems: [
                {
                    xtype: 'toolbar',
                    dock: 'bottom',
                    ui: 'footer',
                    layout: {pack: 'center'},
                    items: [
                        {
                            text: '保存',
                            disabled: true,
                            formBind: true,
                            handler: me.doSave,
                            scope: me
                        },
                        {
                            text: '重置',
                            handler: me.doReset,
                            scope: me
                        }
                    ]
                }
            ]
        });

        me.items = [me.form];
        me.callParent(arguments);
    },

    initEvent: function() {
        this.on('show', this.focusField);
    },

    forcusField: function() {
        var f = this.form.getForm();
        f.findField('Name').focus();
    },

    doSave: function() {
        var me = this,
            f = me.form.getForm(),
            id = f.findField('UserId').getValue();
        if(f.isValid() && f.isDirty()) {
            f.submit({
                waitMsg: '正在保存...',
                success: function(form, action) {
                    var me = this,
                        result = action.result,
                        f = me.form.getForm(),
                        roleName = f.findField('RoleId').getRawValue(),
                        store = Ext.StoreManager.lookup('User'),
                        rec = f.getRecord();
                    f.updateRecord(rec);
                    if(form.actionMethod == 'add') {
                        rec.set('UserId', result.UserId);
                        store.insert(0, rec);
                    }
                    rec.set('CreateTime', result.CreateTime);
                    rec.set('UpdateTime', result.UpdateTime);
                    rec.commit();
                    me.close();
                    // clear form
                    m = store.model;
                    f.loadRecord(new m());
                },
                failure: function(form, action) {
                    if(action.failureType === 'connect') {
                        Ext.Msg.alert('错误', '状态:'+action.respons.status+','+action.respons.statusText);
                        return ;
                    }
                    if(action.failureType === 'server') {
                        Ext.Msg.alert('错误', '提交失败，运行错误！');
                    }
                },
                scope: me
            });
        } else {
            Ext.Msg.alert('修改', '请修改数据后再提交.');
        }
    },

    doReset: function() {
        this.form.getForm().reset();
    }
});
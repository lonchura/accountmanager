/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

Ext.define('AccountManager.view.resource.category.EditView', {
    extend: 'Ext.window.Window',
    alias: 'widget.categoryeditview',

    constrain: true,
    hideMode: 'offsets',
    closeAction: 'hide',
    resizable: false,
    title: '',
    width: 400,
    height: 165,
    modal: true,

    id: 'categoryEditView',

    initComponent: function() {
        var me = this;

        me.form = Ext.create('Ext.form.Panel', {
            border: false,
            bodyPadding: 5,
            bodyStyle: 'background:#DFE9F6',
            trackResetOnLoad: true,
            waitTitle: '请等待...',
            api: {
                submit: AccountManager.Direct.Category.add
            },
            fieldDefaults: {
                labelWidth: 65,
                labelSeparator: ':',
                anchor: '0'
            },
            items: [
                {
                    xtype: 'textfield',
                    fieldLabel: 'ID',
                    name: 'Id',
                    readOnly: true,
                    readOnlyCls: 'x-item-disabled'
                },
                {
                    xtype: 'textfield',
                    fieldLabel: 'ParentID',
                    name: 'parentId',
                    readOnly: true,
                    readOnlyCls: 'x-item-disabled'
                },
                {
                    xtype: 'textfield',
                    fieldLabel: '分类名称',
                    name: 'Name',
                    allowBlank: false,
                    maxLength: 255
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
                            action: 'categorysave',
                            //handler: me.doSave,
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

    doReset: function() {
        this.form.getForm().reset();
    }
});
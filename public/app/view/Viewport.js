Ext.define('AccountManager.view.Viewport', {
    extend: 'Ext.container.Viewport',

    id: 'viewport',
    layout: {type:'vbox', align:'stretch'},
    defaults: {xtype: 'container', style:'background-color:#D3E1F1;'},

    initComponent: function() {
        var me = this;

        me.items = [
            {
                height: 40,
                id: 'logo-container',
                html: 'Account Manager System',
                padding: '0 0 0 20',
                style: 'font-size: 20px; font-weight: bold; line-height: 40px; background-color: #D3E1F1;'
            },
            {xtype: 'mainmenu'},
            {
                xtype: 'panel',
                id: 'contentPage',
                border: false,
                layout: 'card',
                flex: 1,
                padding: '5',
                items: [{
                    title: '欢迎使用账户管理系统',
                    html: '欢迎使用账户管理系统'
                }]
            }
        ];

        this.callParent(arguments);
    },

    listeners: {
        render: function() {
        }
    }
})
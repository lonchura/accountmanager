Ext.define('AccountManager.view.MainMenu', {
    extend: 'Ext.toolbar.Toolbar',
    alias: 'widget.mainmenu',

    id: 'mainmenu',

    initComponent: function() {
        var me = this;

        identity = Ext.state.Manager.get('identity');

        buttons = [];
        buttons.push({text:'资源管理', action:'resource'});
        buttons.push({text:'账号管理', action:'account'});
        buttons.push({text:'分类管理', action:'category'});
        if(identity.role_id===1) {
            buttons.push({text:'用户管理', action:'user'});
        }

        buttons.push('->');
        buttons.push({text:'注销', action:'quit'});

        me.items = buttons;

        this.callParent(arguments);
    }
});
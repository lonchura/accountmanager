Ext.define('AccountManager.controller.MainMenu', {
    extend: 'Ext.app.Controller',

    requires: [
        'AccountManager.view.MainMenu'
    ],

    refs: [
        {ref: 'contentPage', selector: '#contentPage'},
        {ref: 'orderBtn', selector: '#mainmenu button[action=order]'}
    ],

    init: function(app) {
        this.control({
            '#mainmenu button[action=account]': {
                click: this.switchPage
            },
            '#mainmenu button[action=password]': {
                click: this.switchPage
            },
            '#mainmenu button[action=user]': {
                click: this.switchPage
            },
            '#mainmenu button[action=quit]': {
                click: this.Quit
            }
        });
    },

    switchPage: function(btn) {
        var me = this;
        key = btn.action;
        cmp = Ext.getCmp(key + 'View');
        if(cmp) {
            var layout = me.getContentPage().getLayout();
            if(layout.getActiveItem().id != cmp.id) {
                layout.setActiveItem(cmp);
            }
        } else {
            me.getController(Ext.String.capitalize(key));
        }
    },

    Quit: function() {
        AccountManager.Direct.Login.quit({}, function() {
            window.location = '?_dc=' + (new Date()).getTime();
        });
    }
});
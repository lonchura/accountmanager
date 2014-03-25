Ext.define('AccountManager.Application', {
    extend: 'Ext.app.Application',
    name: 'AccountManager',

    controllers: ["MainMenu"],

    autoCreateViewport: true,

    launch: function() {
        AccountManager.app = this;
    }
    
});

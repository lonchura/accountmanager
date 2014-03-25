Ext.ns('AccountManager.Direct');
AccountManager.Direct.REMOTING_API = {
    type: 'remoting',
    url: '/direct/router',
    actions: {
        "AccountManager.Direct.Login": [
            {name: 'check', formHandler:true, len:1},
            {name: 'quit', len:1}
        ]
    }
};
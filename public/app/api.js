Ext.ns('AccountManager.Direct');
AccountManager.Direct.REMOTING_API = {
    type: 'remoting',
    url: '/direct/router',
    actions: {
        "AccountManager.Direct.Login": [
            {name: 'check', formHandler:true, len:1},
            {name: 'vcode', len:1},
            {name: 'quit', len:1}
        ],
        "AccountManager.Direct.Category": [
            {name: 'list', len:1},
            {name: 'add', formHandler:true, len:1},
            {name: 'edit', formHandler:true, len:1},
            {name: 'delete', len:1}
        ],
        "AccountManager.Direct.Resource": [
            {name: 'list', len:1},
            {name: 'add', formHandler:true, len:1},
            {name: 'edit', formHandler:true, len:1},
            {name: 'delete', len:1},
            {name: 'accountList', len:1},
            {name: 'accountAssociate', formHandler:true, len:1},
            {name: 'accountDelete', len:1}
        ],
        "AccountManager.Direct.Account": [
            {name: 'list', len:1},
            {name: 'add', formHandler:true, len:1},
            {name: 'edit', formHandler:true, len:1},
            {name: 'delete', len:1}
        ],
        "AccountManager.Direct.User": [
            {name: 'list', len:1},
            {name: 'add', formHandler:true, len:1},
            {name: 'edit', formHandler:true, len:1},
            {name: 'delete', len:1}
        ],
        "AccountManager.Direct.Role": [
            {name: 'list', len:1}
        ]
    }
};
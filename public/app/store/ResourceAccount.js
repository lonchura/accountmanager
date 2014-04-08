/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

Ext.define('AccountManager.store.ResourceAccount', {
    extend: 'Ext.data.Store',

    model: 'AccountManager.model.ResourceAccount',
    pageSize: 50,

    autoLoad: false,
    remoteFilter: true,
    remoteSort: true,
    sorters: [{property: 'CreateTime', direction: 'DESC'}],

    proxy: {
        type: 'direct',
        batchActions: false,
        api: {
            read: AccountManager.Direct.Resource.accountList,
            destroy: AccountManager.Direct.Resource.accountDelete
        },
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'total'
        }
    }
});
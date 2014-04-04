/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

Ext.define('AccountManager.store.Resource', {
    extend: 'Ext.data.Store',

    model: 'AccountManager.model.Resource',
    pageSize: 50,

    autoLoad: false,
    remoteFilter: true,
    remoteSort: true,
    sorters: [{property: 'Id', direction: 'DESC'}],

    proxy: {
        type: 'direct',
        batchActions: false,
        api: {
            read: AccountManager.Direct.Resource.list,
            destroy: AccountManager.Direct.Resource.delete
        },
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'total'
        }
    }
});
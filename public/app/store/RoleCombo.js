/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

Ext.define('AccountManager.store.RoleCombo', {
    extend: 'Ext.data.Store',

    fields: [
        {name: 'RoleId', type:'int'},
        'RoleName'
    ],
    idProperty: 'RoleId',

    autoLoad: true,
    proxy: {
        type: 'direct',
        directFn: AccountManager.Direct.Role.list,
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});
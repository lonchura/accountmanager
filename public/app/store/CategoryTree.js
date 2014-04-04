/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

Ext.define('AccountManager.store.CategoryTree', {
    extend: 'Ext.data.TreeStore',

    model: 'AccountManager.model.Category',
    root: {Name:'分类', Id:-1, expanded:true},

    proxy: {
        type: 'direct',
        batchActions: false,
        api: {
            read: AccountManager.Direct.Category.list,
            create: AccountManager.Direct.Category.add,
            destroy: AccountManager.Direct.Category.delete,
            update: AccountManager.Direct.Category.edit
        },
        reader: {
            type: 'json',
            root: 'data',
            messageProperty: 'msg'
        }
    }
});
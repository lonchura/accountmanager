/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

Ext.define('AccountManager.model.ResourceAccount', {
    extend: 'Ext.data.Model',

    fields: [
        {name: 'ResourceId', type:'int'},
        {name: 'AccountId', type:'auto'},
        'Identifier',
        'Password',
        {name:'CreateTime', type:'date', dateFormat:'c'}
    ],
    idProperty: 'AccountId'
});
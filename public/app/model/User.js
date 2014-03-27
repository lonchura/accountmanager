/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

Ext.define('AccountManager.model.User', {
    extend: 'Ext.data.Model',

    fields: [
        {name:'UserId', type:'int'},
        'Name',
        'NickName',
        {name:'RoleId', type:'int'},
        'Password',
        {name:'CreateTime', type:'date', dateFormat:'c'},
        {name:'UpdateTime', type:'date', dateFormat:'c'}
    ],

    idProperty:'UserId'
});
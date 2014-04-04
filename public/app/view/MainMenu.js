/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

Ext.define('AccountManager.view.MainMenu', {
    extend: 'Ext.toolbar.Toolbar',
    alias: 'widget.mainmenu',

    id: 'mainmenu',

    initComponent: function() {
        var me = this;

        identity = Ext.state.Manager.get('identity');

        buttons = [];
        buttons.push({text:'资源管理', action:'resource'});
        buttons.push({text:'账号管理', action:'account'});
        if(identity.role_id===1) {
            buttons.push({text:'用户管理', action:'user'});
        }

        buttons.push('->');
        buttons.push({text:'注销', action:'quit'});

        me.items = buttons;

        this.callParent(arguments);
    }
});
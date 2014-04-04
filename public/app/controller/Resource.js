Ext.define('AccountManager.controller.Resource', {
    extend: 'Ext.app.Controller',

    stores: [
        'Resource',
        'CategoryTree'
    ],

    models: [
        'Resource',
        'Category'
    ],

    views: ['resource.View', 'resource.category.EditView'],

    refs: [
        {ref:'contentPage', selector:'#contentPage'},
        {ref:'categoryTreeMenu', selector:'#categoryTreeMenu'}
    ],

    init: function() {
        var me=this,
            view=me.getResourceViewView(),
            c=me.getContentPage();
        me.control({
            '#resourceView': {
                render: this.onPanelRendered
            },
            '#resourceView button[action=categoryrefresh]': {
                click: me.categoryRefresh
            },
            '#categoryTreeMenu menuitem[action=categoryadd]': {
                click: me.categoryAdd
            },
            '#categoryTreeMenu menuitem[action=categoryedit]': {
                click: me.categoryEdit
            },
            '#categoryTreeMenu menuitem[action=categorydelete]': {
                click: me.categoryDelete
            },
            '#categoryEditView button[action=categorysave]': {
                click: me.categorySave
            }
        });
        c.add(view);
    },

    onPanelRendered: function(panel) {
        var me=this,
            c=me.getContentPage();
        me.resourceView = panel;
        c.getLayout().setActiveItem(panel);
    },

    categoryRefresh: function(btn) {
        var me = this;
        me.getCategoryTreeStore().load();
    },

    categoryAdd: function(btn) {
        var me = this,
            win = me.getCategoryEditView(),
            f = win.form,
            m = me.getCategoryTreeStore().model
            categoryRecord = me.getCategoryTreeMenu().record;

        newRecord = new m({parentId: categoryRecord.data.Id});
        f.getForm().api.submit = AccountManager.Direct.Category.add;
        f.getForm().actionMethod = 'add';
        f.loadRecord(newRecord);
        win.setTitle('添加分类');
        win.show();
    },

    categoryEdit: function(btn) {
        var me = this,
            sels = me.resourceView.categoryTree.getSelectionModel().getSelection();
        if(sels.length>0) {
            var rs = sels[0],
                win = me.getCategoryEditView(),
                f = win.form;
            f.getForm().api.submit = AccountManager.Direct.Category.edit;
            f.getForm().actionMethod = 'edit';
            f.getForm().loadRecord(rs);
            win.setTitle('编辑分类');
            win.show();
        } else {
            Ext.Msg.alert('提示信息', '请选择一条记录进行编辑。');
        }
    },

    categoryDelete: function(btn) {
        var tree = this.resourceView.categoryTree,
            sels = this.resourceView.categoryTree.getSelectionModel().getSelection();
        if(sels.length>0) {
            var content = ['确定删除以下分类？'];
            var node = sels[0];
            content.push(node.data.Name + '[' + node.data.Id + ']');
            Ext.Msg.confirm('删除记录', content.join('<br />'), function(btn) {
                if(btn == 'yes') {
                    var me = this;
                    AccountManager.Direct.Category.delete(node.data.Id, function(result, e) {
                        if(result.success) {
                            Ext.Msg.alert('删除成功', '已成功删除', function() {
                                var pNode = me.store.getNodeById(result.data.Id);
                                me.store.load({node: pNode.parentNode});
                            });
                        } else {
                            Ext.Msg.alert('提示信息', result.msg);
                        }
                    })
                }
            }, tree);
        }
    },

    categorySave: function(btn) {
        var me = this,
            win = me.getCategoryEditView(),
            categoryTree = me.getResourceViewView().categoryTree,
            f = win.form;
            //id = f.findField('Id').getValue();
        if(f.isValid() && f.isDirty()) {
            f.submit({
                waitMsg: '正在保存...',
                success: function(form, action) {
                    var me = this,
                        win = me.getCategoryEditView(),
                        categoryTree = me.getContentPage().getLayout().getActiveItem().categoryTree,
                        result = action.result,
                        f = win.form,
                        store = Ext.StoreManager.lookup('CategoryTree'),
                        rec = f.getRecord();
                    f.updateRecord(rec);
                    if(form.actionMethod == 'add') {
                        rec.set('Id', result.Id);
                        rec.set('parentId', result.parentId);
                        rec.set('CreateTime', result.CreateTime);
                        var pNode = store.getNodeById(result.data.parentId);
                        if(!pNode.isLeaf()) {
                            /*if(!pNode.isExpanded()) {
                            }*/
                            store.load({node: pNode});
                        } else {
                            store.load({node: pNode.parentNode});
                        }
                    } else {
                        rec.set('UpdateTime', result.UpdateTime);
                    }
                    rec.commit();
                    win.close();
                    // clear form
                    m = store.model;
                    f.loadRecord(new m());
                },
                failure: function(form, action) {
                    if(action.failureType === 'connect') {
                        Ext.Msg.alert('错误', '状态:'+action.respons.status+','+action.respons.statusText);
                        return ;
                    }
                    if(action.failureType === 'server') {
                        Ext.Msg.alert('错误', action.result.msg);
                    }
                },
                scope: me
            });
        } else {
            Ext.Msg.alert('修改', '请修改数据后再提交.');
        }
    },

    getCategoryEditView: function() {
        var me = this,
            view = me.categoryeditview;
        if(!view) {
            view = me.categoryeditview = Ext.widget('categoryeditview');
        }
        return view;
    }
});
Ext.define("AccountManager.LoginWin",{
	extend:"Ext.window.Window",
    hideMode: 'offsets',
    closeAction: 'hide',
    constrain:true,
    closable:false,
    resizable: false,
    title:'Account Manager System',
    titleAlign:'center',
	singleton:true,
    width: 250,
    height: 160,
    modal:true,
    currentTabIndex:0,
    dockedItems:[],

    initComponent: function() {
    	var me=this;

    	me.fields=[];
    	
    	me.fields.push(
    		Ext.widget("textfield",{
    			fieldLabel:"用户名",
                name:"username",
    			allowBlank:false,
                tabIndex:1,
                colspan: 2,
    			listeners:{
    				scope:me,
    				focus:me.setTabIndex
    			}
    		})
    	);

    	me.fields.push(
    		Ext.widget("textfield",{
    			fieldLabel:"密码",
                name:"password",
                inputType:"password",
    			allowBlank:false,
                tabIndex:2,
                colspan: 2,
    			listeners:{
    				scope:me,
    				focus:me.setTabIndex
    			}
    		})
    	);

    	me.fields.push(
    		Ext.widget("textfield",{
                fieldLabel:"验证码",
                name:"vcode",
    			minLength:4,
                maxLength:4,
    			allowBlank:false,
                tabIndex:3,
                padding: '0 6 0 0',
    			listeners:{
    				scope:me,
    				focus:me.setTabIndex
    			}
    		})
    	);
    	
    	me.image=Ext.create('Ext.Img', {
            border: 1,
            style: {
                cursor: 'pointer',
                borderColor: '#B5B8C8',
                borderStyle: 'solid',
                'margin-top': '-1px'
            },
            listeners: {
                el: {
                    click: function() {
                        me.onRefrehImage();
                    }
                }
            }
        });

        me.imageId=Ext.widget('textfield', {
            inputType: 'hidden',
            style: {
                display: 'none'
            },
            name: 'vcodeId',
            allowBlank: false
        });

    	me.form=Ext.create('Ext.form.Panel',{
            id: "loginForm",
			border:false,
            bodyPadding:5,
            defaultType:"textfield",
            currentTabIndex: 1,
            paramOrder: ['username', 'password', 'vcode'],
			api:{
                submit:AccountManager.Direct.Login.check
            },
            paramsAsHash: false,
			bodyStyle:"background:#DFE9F6",
			fieldDefaults: {
             	labelWidth:80,labelSeparator:"：",anchor:"0"
			},
            layout: {
                type: "table",
                tableAttrs: {style:"width:100%; height:100%"},
                columns: 2
            },
			items:[
				me.fields[0],
				me.fields[1],
                me.fields[2],
                me.image,
                me.imageId
			],
			dockedItems: [{
				xtype: 'toolbar',dock:'bottom',ui:'footer',layout:{pack:"center"},
			    items: [
		    		{text:"登录",disabled:true,formBind:true,handler:me.onLogin,scope:me},
		    		{text:"重置",handler:me.onReset,scope:me},
		    		{text:"刷新验证码",handler:me.onRefrehImage,scope:me}
			    ]
			}]
    	});
    	
    	me.items=[me.form]
    	
    	me.on("show",function(){
    		me.onReset();
    	},me);

    	me.callParent();
	},
	
	initEvents:function(){
		var me=this;
		me.KeyNav=Ext.create("Ext.util.KeyNav",me.form.getEl(),{
			enter:me.onFocus,
			scope:me
		});
	},
	
	onLogin:function(){
		var me=this,
			f=me.form.getForm();
		if(f.isValid()){
			f.submit({
				success: function(form, action){
					me.hide();
					Ext.state.Manager.set("userInfo",action.result.userInfo);
					Ext.create('AccountManager.Application');
				},
                failure: function(form, action){
                    if(action.failureType === Ext.form.action.Action.CONNECT_FAILURE) {
                        Ext.Msg.alertInfo('错误', '状态:'+action.response.status+': '+ action.response.statusText, Ext.Msg.ERROR, me.onRefrehImage, me);
                    }
                	if(action.result){
                		if(action.result.msg) {
                            Ext.Msg.alertInfo('错误', action.result.msg, Ext.Msg.ERROR, me.onRefrehImage, me);
                        }
                    }
                    return ;
                },
                scope:me
			});
		}
	},
	
	onReset:function(){
		var me=this;
		me.form.getForm().reset();
		me.onRefrehImage();
	},
	
	onRefrehImage:function(){
        var me = this;
        this.fields[2].reset();
        Ext.Ajax.request({
            url: '/login/vcode',
            timeout: 3000,
            scope: me,
            params: {
                id: (new Date()).getTime()
            },
            success: function(response) {
                var vcode = eval('(' + response.responseText + ')');
                this.image.setSrc(vcode.imgSrc);
                this.imageId.setValue(vcode.id)
            },
            failure: function(response, opts) {
                Ext.Msg.alert('错误', '获取验证码失败，状态:' + response.status + '，' + response.statusText);
            }
        });
	},
	
	setTabIndex:function(el){
		this.currentTabIndex=el.tabIndex;
	},
	
	onFocus:function(){
		var me=this,
			index=me.currentTabIndex;
			index++;
			if(index>2){
				index=0;
			}
			me.fields[index].focus();
			me.currentTabIndex=index;
	}
})
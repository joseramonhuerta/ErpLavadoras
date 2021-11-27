/*
 * File: main.js
 * Date: Wed Mar 09 2016 19:14:18 GMT-0700 (Hora estándar Montañas (México))
 * 
 * This file was generated by Ext Designer version 1.1.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be generated the first time you export.
 *
 * You should implement event handling and custom methods in this
 * class.
 */
Ext.ns('eno');
eno.mainLogin = Ext.extend(mainUi, {
    initComponent: function() {
        eno.mainLogin.superclass.initComponent.call(this);
		
		
		this.cardLogin.on("afterrender",function(){
			this.cardLogin.getLayout().setActiveItem(0);
		},this);
		
		this.txtUsername.on('afterrender',function(){
			this.txtUsername.focus( true );
		},this);
		
		this.configurarPantallaLogin();
			
			
    },
	
	configurarPantallaLogin:function(){
				
		this.btnIdentificar.on("click",function(){
				this.identificar();
		},this);
		
		this.btnSalir.on("click",function(){
				this.salir();
		},this);
		
		this.txtPass.on('keypress',function(textfield, e){
			if (e.getCharCode()==e.ENTER){
				this.identificar();
			}
		},this);
		
		this.txtUsername.on('keypress',function(textfield, e){
			if (e.getCharCode()==e.ENTER){
				this.txtPass.focus( true );
			}
		},this);
		
	},
	identificar:function(params){
		eno.loginPanel.el.mask(eNuevoOriente.mensajes.mensajeDeEspera);
        var formPanel=this.frmLogin;
		if(formPanel.getForm().isValid()){
			formPanel.getForm().submit({
				url:'app.php/login/identificar',
				scope:this,
				failure: function(form, action){
						eno.loginPanel.el.unmask();
					},					
				success:function(form, action){
					var resp=action.result;
					 
					 if (resp.success == true){
						 window.location = "admin.php";
					 }else{
						Ext.Msg.show({
						   title:'Error',
						   msg: resp.msg,
						   buttons: Ext.Msg.OK,						  						   
						   icon: Ext.MessageBox.ERROR
						});
					 }
					 
					eno.loginPanel.el.unmask();
				}
			});
		}else{
			console.log('Indroduzca usuario y contraseña');
			eno.loginPanel.el.unmask();
		}
	},
	salir:function(params){
		  window.location = "logout.php";
	}
	
});
Ext.reg('mainLogin',eno.mainLogin);
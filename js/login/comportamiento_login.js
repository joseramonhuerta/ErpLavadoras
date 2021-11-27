comportamiento_login={
	identificar:function(params){
		eno.loginPanel.el.mask(eNuevoOriente.mensajes.mensajeDeEspera);
        var formPanel=this.frmLogin;
		
        formPanel.getForm().submit({
            url:'app.php/login/identificarse',
			 scope:this,
            failure:function(){                				
                eno.loginPanel.el.unmask();
            },							
            success:function(form, action){
                 var data=action.result.data;
                 
                 if (action.result.siguiente==2 || action.result.siguiente==3){
                     this.mostrarPantallaCorporativo(data);
                 }
                 if (action.result.siguiente==4){
                     //formPanel.fireEvent("entrar");
                 }
                eno.loginPanel.el.unmask();
            }
        });
	},
	salir:function(params){
		  window.location = "logout.php";
	}
	
}
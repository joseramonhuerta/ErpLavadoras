Ext.ns('eNuevoOriente');
Ext.ns('eno');
Ext.onReady(function(){
    Ext.BLANK_IMAGE_URL = 'images/s.gif';
    Ext.QuickTips.init();

	eNuevoOriente.cronTask = new Ext.util.DelayedTask(function(){
		eNuevoOriente.tareaCronometrada();		
	});
	
	eNuevoOriente.actualizarParametros();	
});

eNuevoOriente.actualizarParametros=function(){
	if (this.creado==undefined){
				CrearLayout();
			}
      
    this.creado=true;
	
	eNuevoOriente.tareaCronometrada(); // manda ejecutar por primera vez esta tarea
	
};	

eNuevoOriente.tareaCronometrada = function(){
		Ext.Ajax.request({ // actualizar los certificados
		url: 'app.php/sistema/verificasesion',
		success: function(){
		}
	});
		
	eNuevoOriente.cronTask.delay(30000); 
};

CrearLayout=function(){
	MainContainer = new eno.Main({
        renderTo: Ext.getBody()
    }).show();
};	


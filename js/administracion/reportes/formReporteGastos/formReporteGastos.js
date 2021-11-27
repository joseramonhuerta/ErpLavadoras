/*
 * File: formReporteGastos.js
 * Date: Thu Feb 02 2017 23:47:25 GMT-0700 (Hora estándar Montañas (México))
 * 
 * This file was generated by Ext Designer version 1.1.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be generated the first time you export.
 *
 * You should implement event handling and custom methods in this
 * class.
 */
Ext.ns('eNuevoOriente');
formReporteGastos = Ext.extend(formReporteGastosUi, {
	idReg:0,
	idSeleccionado:0,
	inicializarStores: function(){
					
		
		var dt = new Date();
		var dt1 = new Date();			
		dt1.setDate(dt1.getDate()-7);	
		this.txtFechaInicio.setValue(dt1);
		this.txtFechaFin.setValue(dt);
		
	  
	},
	inicializarEventos: function(){
		var me = this;
				
		
		this.btnPDF.on('click', function(){
			this.imprimirPDF();
		}, this);	
				
		this.btnExcel.on('click', function(){
			this.imprimirExcel();
		}, this);	
						
		
	},
	
	getParamsImprimir:function(){
		return {
			FechaIni:this.txtFechaInicio.getValue().dateFormat('Y-m-d'),
			FechaFin:this.txtFechaFin.getValue().dateFormat('Y-m-d')
		};
		
		
				
	},
	imprimirPDF:function(){
		if (!this.getForm().isValid()) {	//<---Si hay errores informa al usuario
			 return false;
		}
		var params=this.getParamsImprimir();			
		Ext.Ajax.request({
		params: params,
		   url: 'app.php/gastos/generarreportegastos',
		   success: function(response, opts){
				//Solicita el PDF
				var obj = Ext.decode(response.responseText);
				if (!obj.success){	//Prosegir solo en caso de exito
					return;
				}
				var identificador=obj.data.identificador;
				window.open("app.php/gastos/getpdfgastos?identificador="+identificador,'rep_mov',"height=600,width=800");							
			},
		   failure: function(){
				alert("El servidor ha respondido con un mensaje de error");
			}						   
		   
		});
	},
	
	imprimirExcel: function(){
		if (!this.getForm().isValid()) {	//<---Si hay errores informa al usuario
			 return false;
		}
		var params=this.getParamsImprimir();			
		
		location.href = "app.php/gastos/generarreportegastosexcel?FechaIni="+params.FechaIni+"&FechaFin="+params.FechaFin;
	},
	
	initComponent: function() {
        formReporteGastos.superclass.initComponent.call(this);
		
		this.inicializarStores();
		this.inicializarEventos();
		
		
    }
	
});
Ext.reg('formReporteGastos', formReporteGastos);
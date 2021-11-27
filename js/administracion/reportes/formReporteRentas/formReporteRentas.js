/*
 * File: formAgentes.js
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
formReporteRentas = Ext.extend(formReporteRentasUi, {
	idReg:0,
	idSeleccionado:0,
	inicializarStores: function(){
		this.cmbCliente.store =  new eNuevoOriente.storeFormReporteRentasClientes();
		this.cmbCliente.store.load();	
		this.cmbTrabajador.store = new eNuevoOriente.storeFormReporteRentasTrabajadores();
		this.cmbTrabajador.store.load();					
		
		var dt = new Date();
		var dt1 = new Date();			
		dt1.setDate(dt1.getDate()-7);	
		this.txtFechaInicio.setValue(dt1);
		this.txtFechaFin.setValue(dt);
		
		//this.gridRentas.bottomToolbar.doRefresh();
		
		//this.cmbStatusRenta.store = new eNuevoOriente.storeStatus();  
	},
	inicializarEventos: function(){
		var me = this;
		/*
		var data=new Array(
							{id:-1,nombre:eNuevoOriente.formatearTexto('TODOS')},
							{id:0,nombre:eNuevoOriente.formatearTexto('PENDIENTE')},
							{id:1,nombre:eNuevoOriente.formatearTexto('RENTADA')},
							{id:2,nombre:eNuevoOriente.formatearTexto('COBRADA')},
							{id:3,nombre:eNuevoOriente.formatearTexto('RECOGIDA')}
							
					);
			 this.cmbStatusRenta.store.loadData({data:data});
			 this.cmbStatusRenta.setValue(-1);			
			
		*/
		this.cmbCliente.addListener('beforequery',function(qe){
			delete qe.combo.lastQuery; 	//PARA QUE SIEMPRE REALICE LA CONSULTA AL SERVIDOR
		},this);
		
		this.cmbTrabajador.addListener('beforequery',function(qe){
			delete qe.combo.lastQuery; 	//PARA QUE SIEMPRE REALICE LA CONSULTA AL SERVIDOR
		},this);
		
		this.cmbCliente.onTriggerClick = function(a, e){
			if(e){
				if(e.getAttribute('class').indexOf('x-form-clear-trigger') > -1){
					if(this.isExpanded()){
						this.collapse();
						this.el.focus();
					}
					if(!Ext.isEmpty(me.cmbCliente.getValue())){
						this.reset();	
						
						
					}
				}else{
					if(this.readOnly || this.disabled){
						return;
					}
					if(this.isExpanded()){
						this.collapse();
						this.el.focus();
					}else {
						this.onFocus({});
						if(this.triggerAction == 'all') {
							this.doQuery(this.allQuery, true);
						} else {
							this.doQuery(this.getRawValue());
						}
						this.el.focus();
					}
				} 
			}
		};
		
		this.cmbTrabajador.onTriggerClick = function(a, e){
			if(e){
				if(e.getAttribute('class').indexOf('x-form-clear-trigger') > -1){
					if(this.isExpanded()){
						this.collapse();
						this.el.focus();
					}
					if(!Ext.isEmpty(me.cmbTrabajador.getValue())){
						this.reset();	
						
						
					}
				}else{
					if(this.readOnly || this.disabled){
						return;
					}
					if(this.isExpanded()){
						this.collapse();
						this.el.focus();
					}else {
						this.onFocus({});
						if(this.triggerAction == 'all') {
							this.doQuery(this.allQuery, true);
						} else {
							this.doQuery(this.getRawValue());
						}
						this.el.focus();
					}
				} 
			}
		};		
		
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
			FechaFin:this.txtFechaFin.getValue().dateFormat('Y-m-d'),
			IDCliente:this.cmbCliente.getValue(),
			IDTrabajador:this.cmbTrabajador.getValue(),
			Cliente:this.cmbCliente.getRawValue(),
			Trabajador:this.cmbTrabajador.getRawValue()
		};
		
		
				
	},
	imprimirPDF:function(){
		if (!this.getForm().isValid()) {	//<---Si hay errores informa al usuario
			 return false;
		}
		var params=this.getParamsImprimir();			
		Ext.Ajax.request({
		params: params,
		   url: 'app.php/pedidos/generarreporterentas',
		   success: function(response, opts){
				//Solicita el PDF
				var obj = Ext.decode(response.responseText);
				if (!obj.success){	//Prosegir solo en caso de exito
					return;
				}
				var identificador=obj.data.identificador;
				window.open("app.php/pedidos/getpdfrentas?identificador="+identificador,'rep_mov',"height=600,width=800");							
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
		
		location.href = "app.php/pedidos/generarreporterentasexcel?FechaIni="+params.FechaIni+"&FechaFin="+params.FechaFin+"&IDCliente="+params.IDCliente+"&IDTrabajador="+params.IDTrabajador/*+"&StatusRenta="+params.StatusRenta*/;
	},
	
	initComponent: function() {
        formReporteRentas.superclass.initComponent.call(this);
		
		this.inicializarStores();
		this.inicializarEventos();
		
		
    }
	
});
Ext.reg('formReporteRentas', formReporteRentas);

/*
 * File: formRentasGridPagosWindow.js
 * Date: Sun Jun 11 2017 16:13:12 GMT-0600 (Hora verano, Montañas (México))
 * 
 * This file was generated by Ext Designer version 1.1.2.
 * http://www.sencha.com/products/designer/
 *
 * This file will be generated the first time you export.
 *
 * You should implement event handling and custom methods in this
 * class.
 */

formRentasGridPagosWindow = Ext.extend(formRentasGridPagosWindowUi, {
	idReg: 0,
	id_pedido: 0,
	idSeleccionado: 0,
	inicializarStores: function(){
		this.gridRentasPagos.store=new eNuevoOriente.storeGridRentasPagos();
		this.gridRentasPagos.bottomToolbar.bindStore(this.gridRentasPagos.getStore());
		this.gridRentasPagos.bottomToolbar.pageSize=eNuevoOriente.parametros.registros_pagina;
		
		this.on('afterrender', function(){
			this.gridRentasPagos.bottomToolbar.doRefresh();
		}, this);
		
		this.btnEliminarPago.on('click', function(){
			this.eliminarpago();
		}, this);
		
		this.btnEditarPago.on('click', function(){
			this.editarpago();
		}, this);
		
		// this.gridRentasPagos.store.on('load',function(){
			// this.el.unmask();
		// },this);
		
		this.gridRentasPagos.on('rowclick', this.onRowClick, this);
		
		this.gridRentasPagos.on('celldblclick', this.editarpago , this);
	},
	inicializarEventos: function(){
		this.gridRentasPagos.store.on('beforeload',function(){
			this.gridRentasPagos.store.baseParams=this.gridRentasPagos.store.baseParams || {};
			this.gridRentasPagos.store.baseParams.id_pedido=this.id_pedido || 0;
			
		},this);
				
		
	},
			
	initComponent: function() {
        formRentasGridPagosWindow.superclass.initComponent.call(this);
		this.inicializarStores();
		this.inicializarEventos();
    },
	
	editarpago:function(Grid, rowIndex, columnIndex, e){
		var record = this.gridRentasPagos.store.getAt(this.idSeleccionado);
		var id = record.data.id_pago;		
			
		this.formPagoWin = new formRentasPagosWindow();
		this.formPagoWin.idReg = id;
		this.formPagoWin.id_pedido = this.id_pedido;
		this.formPagoWin.show();
		
		this.formPagoWin.on("pagoGuardado", function(){
			this.gridRentasPagos.bottomToolbar.doRefresh();
		}, this);
		
		
	},
	eliminarpago:function(btn,id){
		switch(btn){	//ESTE SWITCH ES USADO PARA ANALIZAR LO QUE TRATA DE HACER EL USUARIO, LA PRIERA VEZ DEBE ENTRAR A default:
    	case 'no':
    		return;
    	break;
    	case 'yes':
    		this.eliminarpago('borrar');
    		return;
    		break;
    	case 'borrar':
    		break;		//SALE DEL SWITCH Y SIGUE EJECUTANDOSE LA FUNCI�N
    	case undefined:	//AQUI ENTRA LA PRIMERA VEZ
    	case false:    		
    	default:
    		var me=this;    		
    		Ext.Msg.show({
 			   title:'Confirme por favor',
 			   msg: "¿Desea eliminar el pago?",
 			   buttons: Ext.Msg.YESNO,
 			   fn: function(btn){	    				
    				me.eliminarpago(btn);
    			},
 			   scope:this,
 			   icon: Ext.MessageBox.QUESTION
 			});
    		return;
		} 
		
		if (id==undefined){	//obtener el id del registro seleccionado
    		var  sel=this.gridRentasPagos.getSelectionModel().getSelections();
    		if (sel.length==undefined || sel.length==0){
    			return;
    		}else{
    			id=sel[0].id;    			
    		}
    	}
		
		this.el.mask(eno.mensajeDeEspera);
		Ext.Ajax.request({
			params: { id_pago: id },
			scope:this,
		   	url: 'app.php/pedidos/eliminarpago',
		   	success: function(response,options){	
				var respuesta=Ext.decode(response.responseText);
				if (respuesta.success==false){
					this.el.unmask();
					return;
				}
				this.el.unmask();
				this.gridRentasPagos.bottomToolbar.doRefresh();		
				this.fireEvent("pagoEliminado");
		   	},
		   	failure: function(){
		   		this.el.unmask();
		   	}		   
		});
	},
	onRowClick : function( grid ,rowIndex, e ){
		var  sel=this.gridRentasPagos.getSelectionModel().getSelections();
		if (sel.length==undefined || sel.length==0){
			this.btnEliminarPago.setDisabled(true);
			this.btnEditarPago.setDisabled(true);
			this.idSeleccionado = rowIndex;
			
		}else{
			this.btnEliminarPago.setDisabled(false);
			this.btnEditarPago.setDisabled(false);			
			this.idSeleccionado = rowIndex;
		}
		
		
	}
});
Ext.reg('formRentasGridPagosWindow', formRentasGridPagosWindow);
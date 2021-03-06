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
formPedidos = Ext.extend(formPedidosUi, {
	idReg:0,
	idSeleccionado:0,
	renderStatusEntrega:function(val,m,rec,x,ix,s){
		var value = '';
		if(val==3)
			value = '<img src="images/iconos/status3.png" />'
		else if(val==2)
			value = '<img src="images/iconos/status2.png" />'
		else
			value = '<img src="images/iconos/status1.png" />'
		
		if (rec.data.status_entrega == 3){
            m.attr =
            'ext:qtip="' + 
                "<div class='toolTip-Informacion'>Retrasado</div>" + 
            '"';
            
        }else if (rec.data.status_entrega == 2){
            m.attr =
            'ext:qtip="' + 
                "<div class='toolTip-Informacion'>Urgente</div>" + 
            '"';
            
        }else{
			m.attr =
            'ext:qtip="' + 
                "<div class='toolTip-Informacion'>Entregar</div>" + 
            '"';
		}	
		
		
		return value;
	},
	renderStatusAutorizada:function(val,m,rec,x,ix,s){
		var value = '';
		if(val==1)
			value = '<img src="images/iconos/autorizada.png" />'
		else
			value = '<img src="images/iconos/noautorizada.png" />'
		
		if (rec.data.autorizada == 1){
            m.attr =
            'ext:qtip="' + 
                "<div class='toolTip-Informacion'>Autorizada</div>" + 
            '"';
            
        }else{
			m.attr =
            'ext:qtip="' + 
                "<div class='toolTip-Informacion'>No Autorizada</div>" + 
            '"';
		}	
		
		
		return value;
	},
	renderStatusOrigen:function(val,m,rec,x,ix,s){
		var value = '';
		if(val==2)
			value = '<img src="images/iconos/celular.png" />'
		else
			value = '<img src="images/iconos/vacio.png" />'
		
		if (rec.data.origen == 2){
            m.attr =
            'ext:qtip="' + 
                "<div class='toolTip-Informacion'>Aplicación</div>" + 
            '"';
            
        }else{
			m.attr =
            'ext:qtip="' + 
                "<div class='toolTip-Informacion'>Sistema Web</div>" + 
            '"';
		}	
		
		
		return value;
	},
	inicializarStores: function(){
		this.cmbCliente.store =  new eNuevoOriente.storeFormPedidosClientes();
		this.cmbRuta.store = new eNuevoOriente.storeFormPedidosRuta();	
		this.cmbRuta.store.load();	
		this.cmbPlazoPago.store = new eNuevoOriente.storeFormPedidosPlazoPagos();
		this.cmbTrabajador.store = new eNuevoOriente.storeFormPedidosTrabajadores();
		this.cmbTrabajador.store.load();		
		
		this.cmbStatusPedido.store = new eNuevoOriente.storeStatus();  
		
		this.txtChofer.store = new eNuevoOriente.storeFormPedidosTrabajadoresPorRuta();
		this.txtChofer.store.load();	
		
		this.gridPedidos.store=new eNuevoOriente.storeGridPedidos();
		this.gridPedidos.bottomToolbar.bindStore(this.gridPedidos.getStore());
		this.gridPedidos.bottomToolbar.pageSize=eNuevoOriente.parametros.registros_pagina;
	},
	inicializarEventos: function(){
		var me = this;
		
		var data=new Array(
							{id:'A',nombre:eNuevoOriente.formatearTexto('ACTIVOS')},
							{id:'I',nombre:eNuevoOriente.formatearTexto('INACTIVOS')},
							{id:'T',nombre:eNuevoOriente.formatearTexto('TODOS')}
					);
			 this.cmbStatusPedido.store.loadData({data:data});
			 this.cmbStatusPedido.setValue(eNuevoOriente.formatearTexto('A'));	
				
		var dt = new Date();			
		this.txtFechaEntrega.setValue(dt);
		this.txtHoraEntrega.setValue(dt.format('H:i:s A'));		
		
		this.cmbCliente.addListener('beforequery',function(qe){
			delete qe.combo.lastQuery; 	//PARA QUE SIEMPRE REALICE LA CONSULTA AL SERVIDOR
		},this);
		
		this.cmbTrabajador.addListener('beforequery',function(qe){
			delete qe.combo.lastQuery; 	//PARA QUE SIEMPRE REALICE LA CONSULTA AL SERVIDOR
		},this);
		
		this.txtChofer.addListener('beforequery',function(qe){
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
						me.txtColonia.setValue('');
						me.txtCalle.setValue('');
						//me.cmbRuta.setValue('');
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
		
		this.cmbCliente.on('select',function(combo, record, index){
			var colonia = record.get('colonia');
			var calle = record.get('calle');
			var id_ruta = record.get('id_ruta');
			//var chofer = record.get('chofer');
			//var id_trabajador = record.get('id_trabajador');
						
			this.txtColonia.setValue(colonia);
			this.txtCalle.setValue(calle);
			this.cmbRuta.setValue(id_ruta);
			//this.txtChofer.setValue(chofer);
			//this.cmbTrabajador.setValue(id_trabajador);
			//this.txtIdTrabajador.setValue(id_trabajador);
		},this);

		this.cmbRuta.on('select',function(combo, record, index){
			//var chofer = record.get('chofer');			
			//this.txtChofer.setValue(chofer);
			this.txtChofer.reset();
		},this);

		this.txtChofer.on('select',function(combo, record, index){
			var id_trabajador = record.get('id_trabajador');
			var nombre_trabajador = record.get('nombre_trabajador');
			
			//this.cmbTrabajador.store.load();
			this.cmbTrabajador.setValue(id_trabajador);
			//this.cmbTrabajador.setRawValue(nombre_trabajador);
			this.txtIdTrabajador.setValue(id_trabajador);
			
			var valor = record.get('ruta');			
			this.txtRuta.setValue(valor);
			
			
			
		},this);

		this.txtChofer.store.on('beforeload',function(){
			this.txtChofer.store.baseParams=this.txtChofer.store.baseParams || {};
			this.txtChofer.store.baseParams.id_ruta=this.cmbRuta.getValue() || 0;
			
			
		},this);		
		
		 var data=new Array(
							{id:'1',nombre:eNuevoOriente.formatearTexto('SEMANAL'),valor:'230.00'},
							{id:'2',nombre:eNuevoOriente.formatearTexto('1 DIA'),valor:'100.00'},
							{id:'3',nombre:eNuevoOriente.formatearTexto('2 DIAS'),valor:'150.00'},
							{id:'4',nombre:eNuevoOriente.formatearTexto('3 DIAS'),valor:'180.00'}
					);		
		this.cmbPlazoPago.store.loadData({data:data}); 
		//this.cmbPlazoPago.setValue(1);
		
		this.cmbPlazoPago.on('select',function(combo, record, index){
			var valor = record.get('valor');			
			this.txtPrecioRenta.setValue(valor);
			
		},this);
		/*
		this.cmbRuta.on('select',function(combo, record, index){
			var valor = record.get('id_trabajador');			
			this.cmbTrabajador.setValue(valor);
			this.txtIdTrabajador.setValue(valor);
			var valor = record.get('descripcion');			
			this.txtRuta.setValue(valor);
			
		},this);
		*/
		this.cmbTrabajador.on('select',function(combo, record, index){
			var valor = record.get('ruta');			
			this.txtRuta.setValue(valor);
			
		},this);
		/*
		this.cmbTrabajador.store.on('load',function(){
			this.cmbTrabajador.setValue(this.txtIdTrabajador.getValue());
		},this);	
		*/
		this.btnCancelar.on('click', function(){
			this.formPedidos.getForm().reset();
		}, this );
		
		this.btnGuardar.on('click', function(){
			this.guardar();
		}, this );
		
		this.btnActualizar.on('click', function(){
			this.gridPedidos.bottomToolbar.doRefresh();
		}, this );
		
		this.txtFiltro.on('specialkey',function(comp,e){		
			if (e.getCharCode()==e.ENTER){
				this.gridPedidos.bottomToolbar.doRefresh();
			}
		},this);
		
		this.cmbStatusPedido.on('select',function(combo, record, index){	
				this.gridPedidos.bottomToolbar.doRefresh();			
		},this);
		
		this.gridPedidos.store.on('beforeload',function(){
				 
				this.gridPedidos.store.baseParams=this.gridPedidos.store.baseParams || {};
				this.gridPedidos.store.baseParams.filtro=this.txtFiltro.getValue();
				this.gridPedidos.store.baseParams.filtroStatus=this.cmbStatusPedido.getValue();
			},this);
		
		this.gridPedidos.store.on('load',function(){
			this.el.unmask();
		},this);
		
		 this.gridPedidos.on('rowclick', this.onRowClick, this);
		 
		this.btnEditar.on('click', function(){
			this.editar();
			
		}, this); 
		
		this.btnCancelarPedido.on('click', function(){
			this.eliminar();
			
		}, this);

		this.btnAutorizarPedido.on('click', function(){
			this.autorizar();
			
		}, this); 		
		
		this.tabPedidos.on('tabchange', this.tabchange, this);	
				
		this.gridPedidos.on('celldblclick', this.editar , this);
		
	},
	tabchange: function(sender, tab){		
		switch(tab.getItemId()){
			case 'tab_pedidos': 
				this.gridPedidos.bottomToolbar.doRefresh();	
			break;
		}
	},
	inizializaTpls:function(){
		this.cmbCliente.tpl = new Ext.XTemplate(
			'<tpl for=".">'+
				'<div class="x-combo-list-item">'+
					'<div><b>{nombre}</b></div>'+
					'<div><i>{calle}</i></div>'+
					'<div><i>{celular}</i></div>'+
				'</div>'+
			'</tpl>'
		);
		
		
		
	},
	inicializaRenders: function(){
		var colModel=this.gridPedidos.getColumnModel();
		var columnaStatus=colModel.getColumnById('colStatusEntrega');
        columnaStatus.renderer=this.renderStatusEntrega;
		
		var columnaAutorizada=colModel.getColumnById('colAutorizada');
        columnaAutorizada.renderer=this.renderStatusAutorizada;
		
		var columnaOrigen=colModel.getColumnById('colOrigen');
        columnaOrigen.renderer=this.renderStatusOrigen;
	},
	initComponent: function() {
        formPedidos.superclass.initComponent.call(this);
		this.gridPedidos.columnaStatus="status";
		this.inicializarStores();
		this.inicializarEventos();
		this.inizializaTpls();
		this.inicializaRenders();
		
    },
	editar: function(Grid, rowIndex, columnIndex, e){		
		var record = this.gridPedidos.store.getAt(this.idSeleccionado);				
			var id = record.data.id_pedido;
			
			this.formPedidoWin = new formPedidosWindow();
				this.formPedidoWin.id_pedido = id;
				this.formPedidoWin.show();
				
				this.formPedidoWin.on("pedidoGuardado", function(){
					this.gridPedidos.bottomToolbar.doRefresh();		
				}, this);
		
	},
	guardar:function(){
		if (this.formPedidos.getForm().isValid()){			
			var params={};		

			var fecha = this.txtFechaEntrega.getValue();
			fecha=fecha.format('Y-m-d');  
			params['Pedido[id_pedido]'] = this.idReg;
			params['Pedido[fecha]'] = fecha;
			params['Pedido[hora]'] = this.txtHoraEntrega.getValue();
			params['Pedido[id_cliente]'] = this.cmbCliente.getValue();
			params['Pedido[id_ruta]'] = this.cmbRuta.getValue();
			params['Pedido[id_trabajador]'] = this.txtChofer.getValue();			
			params['Pedido[referencia]'] = this.txtReferencia.getValue();			
			params['Pedido[plazo_pago]'] = this.cmbPlazoPago.getValue();
			params['Pedido[precio_renta]'] = this.txtPrecioRenta.getValue();			
			params['Pedido[observaciones]'] = this.txtObservaciones.getValue();			
			params['Pedido[id_trabajador_ocacional]'] = this.cmbTrabajador.getValue();
			
			this.el.mask('Guardando...');
			this.formPedidos.getForm().submit({
				params:params,
				scope:this,
				url:'app.php/pedidos/guardar',
				success:function(){
					this.el.unmask();
					this.idReg=0;
					this.formPedidos.getForm().reset();
					
				},
				failure:function(form, action){
					switch (action.failureType) {
		            case Ext.form.Action.CLIENT_INVALID:		                
		                msg="Favor de revisar los campos marcados";
		                icon=Ext.MessageBox.WARNING;
		                break;
		            case Ext.form.Action.CONNECT_FAILURE:		                
		                msg="Error en la comunicación ajax, intente de nuevo";
		                icon=Ext.MessageBox.ERROR;
		                break;
		            case Ext.form.Action.SERVER_INVALID:
		                icon=Ext.MessageBox.ERROR;
		                msg=action.result.msg;
					}
					Ext.Msg.show({
					   title:'Error',
					   msg: msg,
					   buttons: Ext.Msg.OK,						  						   
					   icon: icon
					});
					this.el.unmask();
					}

				});
				
			
		}else{
			return;
			
		}	
		
		
	},
	onRowClick : function( grid ,rowIndex, e ){
		var  sel=this.gridPedidos.getSelectionModel().getSelections();
		if (sel.length==undefined || sel.length==0){
			this.btnEditar.setDisabled(true);
		}else{
			this.btnEditar.setDisabled(false);
			this.idSeleccionado = rowIndex;
		}
		if (sel.length==undefined || sel.length==0){
			this.btnCancelarPedido.setDisabled(true);
		}else{
			this.btnCancelarPedido.setDisabled(false);
			this.idSeleccionado = rowIndex;
		}
		if (sel.length==undefined || sel.length==0){
			this.btnAutorizarPedido.setDisabled(true);
		}else{
			this.btnAutorizarPedido.setDisabled(false);
			this.idSeleccionado = rowIndex;
		}
		
	},
	eliminar:function(btn,id){
		switch(btn){	//ESTE SWITCH ES USADO PARA ANALIZAR LO QUE TRATA DE HACER EL USUARIO, LA PRIERA VEZ DEBE ENTRAR A default:
    	case 'no':
    		return;
    	break;
    	case 'yes':
    		this.eliminar('borrar');
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
 			   msg: "¿Desea eliminar el Pedido?",
 			   buttons: Ext.Msg.YESNO,
 			   fn: function(btn){	    				
    				me.eliminar(btn);
    			},
 			   scope:this,
 			   icon: Ext.MessageBox.QUESTION
 			});
    		return;
		} 
		
		if (id==undefined){	//obtener el id del registro seleccionado
    		var  sel=this.gridPedidos.getSelectionModel().getSelections();
    		if (sel.length==undefined || sel.length==0){
    			return;
    		}else{
    			id=sel[0].id;    			
    		}
    	}
		
		this.el.mask(eno.mensajeDeEspera);
		Ext.Ajax.request({
			params: { id_pedido: id },
			scope:this,
		   	url: 'app.php/pedidos/eliminar',
		   	success: function(response,options){	
				var respuesta=Ext.decode(response.responseText);
				if (respuesta.success==false){
					this.el.unmask();
					return;
				}
				this.idReg=0;
				
				this.gridPedidos.bottomToolbar.doRefresh();			
				
		   	},
		   	failure: function(){
		   		this.el.unmask();
		   	}		   
		});
	},
	autorizar:function(btn,id){
		switch(btn){	//ESTE SWITCH ES USADO PARA ANALIZAR LO QUE TRATA DE HACER EL USUARIO, LA PRIERA VEZ DEBE ENTRAR A default:
    	case 'no':
    		return;
    	break;
    	case 'yes':
    		this.autorizar('autorizar');
    		return;
    		break;
    	case 'autorizar':
    		break;		//SALE DEL SWITCH Y SIGUE EJECUTANDOSE LA FUNCI�N
    	case undefined:	//AQUI ENTRA LA PRIMERA VEZ
    	case false:    		
    	default:
    		var me=this;    		
    		Ext.Msg.show({
 			   title:'Confirme por favor',
 			   msg: "¿Desea autorizar el Pedido?",
 			   buttons: Ext.Msg.YESNO,
 			   fn: function(btn){	    				
    				me.autorizar(btn);
    			},
 			   scope:this,
 			   icon: Ext.MessageBox.QUESTION
 			});
    		return;
		} 
		
		if (id==undefined){	//obtener el id del registro seleccionado
    		var  sel=this.gridPedidos.getSelectionModel().getSelections();
    		if (sel.length==undefined || sel.length==0){
    			return;
    		}else{
    			id=sel[0].id;    			
    		}
    	}
		
		this.el.mask(eno.mensajeDeEspera);
		Ext.Ajax.request({
			params: { id_pedido: id },
			scope:this,
		   	url: 'app.php/pedidos/autorizar',
		   	success: function(response,options){	
				var respuesta=Ext.decode(response.responseText);
				if (respuesta.success==false){
					this.el.unmask();
					return;
				}
				this.idReg=0;
				
				this.gridPedidos.bottomToolbar.doRefresh();			
				
		   	},
		   	failure: function(){
		   		this.el.unmask();
		   	}		   
		});
	}
	
	
});
Ext.reg('formPedidos', formPedidos);

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
formAsignacion = Ext.extend(formAsignacionUi, {
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
	inicializarStores: function(){
		
		this.cmbTrabajador.store = new eNuevoOriente.storeFormAsignacionTrabajadores();
		this.cmbTrabajador.store.load();		
		this.cmbProducto.store =  new eNuevoOriente.storeFormAsignacionProductos();
		
		
		
		this.gridAsignados.store=new eNuevoOriente.storeGridAsignacion();
		this.gridAsignados.bottomToolbar.bindStore(this.gridAsignados.getStore());
		this.gridAsignados.bottomToolbar.pageSize=eNuevoOriente.parametros.registros_pagina;
	},
	inicializarEventos: function(){
		var me = this;
		
		
				
		var dt = new Date();			
		this.txtFecha.setValue(dt);
				
		
		this.cmbProducto.addListener('beforequery',function(qe){
			delete qe.combo.lastQuery; 	//PARA QUE SIEMPRE REALICE LA CONSULTA AL SERVIDOR
		},this);
		
		this.cmbTrabajador.addListener('beforequery',function(qe){
			delete qe.combo.lastQuery; 	//PARA QUE SIEMPRE REALICE LA CONSULTA AL SERVIDOR
		},this);
		
		this.cmbTrabajador.onTriggerClick = function(a, e){
			if(e){
				if(e.getAttribute('class').indexOf('x-form-clear-trigger') > -1){
					if(this.isExpanded()){
						this.collapse();
						this.el.focus();
					}
					if(!Ext.isEmpty(me.cmbTrabajador.getValue())){
						this.reset();	
						me.txtRuta.setValue('');
						me.txtChofer.setValue('');
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
		
		this.cmbProducto.onTriggerClick = function(a, e){
			if(e){
				if(e.getAttribute('class').indexOf('x-form-clear-trigger') > -1){
					if(this.isExpanded()){
						this.collapse();
						this.el.focus();
					}
					if(!Ext.isEmpty(me.cmbProducto.getValue())){
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
		
		this.cmbTrabajador.on('select',function(combo, record, index){
			var ruta = record.get('ruta');
			var chofer = record.get('nombre_trabajador');			
			this.txtRuta.setValue(ruta);
			this.txtChofer.setValue(chofer);
		},this);	
		
		this.btnCancelar.on('click', function(){
			this.formAsignacion.getForm().reset();
		}, this );
		
		this.btnGuardar.on('click', function(){
			this.guardar();
		}, this );
		
		this.btnActualizar.on('click', function(){
			this.gridAsignados.bottomToolbar.doRefresh();
		}, this );
		
		this.txtFiltro.on('specialkey',function(comp,e){		
			if (e.getCharCode()==e.ENTER){
				this.gridAsignados.bottomToolbar.doRefresh();
			}
		},this);
		
		this.btnRegresarBodega.on('click',function(){	
			this.regresarabodega();			
		},this);
		
		
		this.gridAsignados.store.on('beforeload',function(){
				 
				this.gridAsignados.store.baseParams=this.gridAsignados.store.baseParams || {};
				this.gridAsignados.store.baseParams.filtro=this.txtFiltro.getValue();
				
			},this);
		
		this.gridAsignados.store.on('load',function(){
			this.el.unmask();
		},this);
		
		 this.gridAsignados.on('rowclick', this.onRowClick, this);
		 
		// this.btnEditar.on('click', function(){
			// this.editar();
			
		// }, this); 
		
		this.tabAsignaciones.on('tabchange', this.tabchange, this);	
				
		// this.gridAsignados.on('celldblclick', this.editar , this);
		
	},
	tabchange: function(sender, tab){		
		switch(tab.getItemId()){
			case 'tab_asignadas': 
				this.gridAsignados.bottomToolbar.doRefresh();	
			break;
		}
	},
	inizializaTpls:function(){
		
		this.cmbProducto.tpl = new Ext.XTemplate(
			'<tpl for=".">'+
				'<div class="x-combo-list-item">'+
					'<div><b>{descripcion}</b></div>'+
					'<div><i>{codigo_barra}</i></div>'+					
				'</div>'+
			'</tpl>'
		);
		
	},
	inicializaRenders: function(){
		var colModel=this.gridAsignados.getColumnModel();
		var columna=colModel.getColumnById('colStatusEntrega');
        columna.renderer=this.renderStatusEntrega;
	},
	initComponent: function() {
        formAsignacion.superclass.initComponent.call(this);
		// this.gridAsignados.columnaStatus="status";
		this.inicializarStores();
		this.inicializarEventos();
		this.inizializaTpls();
		// this.inicializaRenders();
		
    },
	guardar:function(){
		if (this.formAsignacion.getForm().isValid()){			
			var params={};		

			var fecha = this.txtFecha.getValue();
			fecha=fecha.format('Y-m-d');  
			params['Asignacion[id_asignacion]'] = this.idReg;
			params['Asignacion[fecha]'] = fecha;							
			params['Asignacion[id_trabajador]'] = this.cmbTrabajador.getValue();
			params['Asignacion[id_producto]'] = this.cmbProducto.getValue();							
			
			this.el.mask('Guardando...');
			this.formAsignacion.getForm().submit({
				params:params,
				scope:this,
				url:'app.php/pedidos/guardarasignacion',
				success:function(){
					this.el.unmask();
					this.idReg=0;
					this.formAsignacion.getForm().reset();
					
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
		var  sel=this.gridAsignados.getSelectionModel().getSelections();
		if (sel.length==undefined || sel.length==0){
			this.btnRegresarBodega.setDisabled(true);
			this.idSeleccionado = rowIndex;
		}else{
			this.btnRegresarBodega.setDisabled(false);
			this.idSeleccionado = rowIndex;
		}
		
		
	},
	regresarabodega:function(btn,id){
		switch(btn){	//ESTE SWITCH ES USADO PARA ANALIZAR LO QUE TRATA DE HACER EL USUARIO, LA PRIERA VEZ DEBE ENTRAR A default:
    	case 'no':
    		return;
    	break;
    	case 'yes':
    		this.regresarabodega('borrar');
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
 			   msg: "¿Desea regresar a bodega?",
 			   buttons: Ext.Msg.YESNO,
 			   fn: function(btn){	    				
    				me.regresarabodega(btn);
    			},
 			   scope:this,
 			   icon: Ext.MessageBox.QUESTION
 			});
    		return;
		} 
		
		if (id==undefined){	//obtener el id del registro seleccionado
    		var  sel=this.gridAsignados.getSelectionModel().getSelections();
    		if (sel.length==undefined || sel.length==0){
    			return;
    		}else{
    			id=sel[0].id;    			
    		}
    	}
		
		this.el.mask(eno.mensajeDeEspera);
		Ext.Ajax.request({
			params: { id_asignacion: id },
			scope:this,
		   	url: 'app.php/pedidos/regresarabodega',
		   	success: function(response,options){	
				var respuesta=Ext.decode(response.responseText);
				if (respuesta.success==false){
					this.el.unmask();
					return;
				}
				
				this.gridAsignados.bottomToolbar.doRefresh();		
				
		   	},
		   	failure: function(){
		   		this.el.unmask();
		   	}		   
		});
	}
	
	
});
Ext.reg('formAsignacion', formAsignacion);

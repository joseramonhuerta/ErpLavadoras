/*
 * File: Main.js
 * Date: Fri Mar 04 2016 20:00:37 GMT-0700 (Hora estándar Montañas (México))
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
Ext.ns('eno');
Ext.ns('eNuevoOriente.parametros');
var App = new Ext.App({});
Ext.override(Ext.grid.GridPanel, ekoGrid);

eno.permisos=new Array();
eno.Main = Ext.extend(MainUi, {
    initComponent: function() {
        eno.Main.superclass.initComponent.call(this);
		this.obtenerInformacionInicial();
		
		
		this.btnUsuarios.on('click',function(){	
			var id_modulo = 1;
			
			var params={            
				   xtype:'formUsuarios',           
				   idValue:0,
				   title:'Usuarios',
				   closable: true,
				   iconCls: 'tab-usuarios',
				   modulo: id_modulo
				};
			
			this.validarPermisoModulo(id_modulo,params);
			
			
		},this);
		
		this.btnClientes.on('click',function(){	
			var id_modulo = 2;	   
		   
			var params={            
			   xtype:'formClientes',           
			   idValue:0,
			   title:'Clientes',
			   closable: true,
			   iconCls: 'tab-clientes'
			};				
				
			this.validarPermisoModulo(id_modulo,params);
		},this);
		
		this.btnTrabajadores.on('click',function(){	
			var id_modulo = 3;
			var params={            
			   xtype:'formTrabajadores',           
			   idValue:0,
			   title:'Trabajadores',
			   closable: true,
			   iconCls: 'tab-clientes'
		   };
					
		   this.validarPermisoModulo(id_modulo,params);
		},this);
		
		this.btnPedidos.on('click',function(){	
			var id_modulo = 4;
			var params={            
			   xtype:'formPedidos',           
			   idValue:0,
			   title:'Pedidos',
			   closable: true,
			   iconCls: 'tab-pedidos'
		   };
					
		   this.validarPermisoModulo(id_modulo,params);
		},this);
		
		this.btnAsignacion.on('click',function(){	
			var id_modulo = 5;
			var params={            
			   xtype:'formAsignacion',           
			   idValue:0,
			   title:'Asignacion',
			   closable: true,
			   iconCls: 'tab-asignacion'
		   };
					
		   this.validarPermisoModulo(id_modulo,params);
		},this);
		
		this.btnRentas.on('click',function(){	
			var id_modulo = 6;
			var params={            
			   xtype:'formRentas',           
			   idValue:0,
			   title:'Registros Rentas',
			   closable: true,
			   iconCls: 'tab-rentas'
		   };
					
		   this.validarPermisoModulo(id_modulo,params);
		},this);
		
		this.btnProductos.on('click',function(){	
			var id_modulo = 7;
			var params={            
			   xtype:'formProductos',           
			   idValue:0,
			   title:'Productos',
			   closable: true,
			   iconCls: 'tab-productos'
		   };
					
		   this.validarPermisoModulo(id_modulo,params);
		},this);
		
		this.btnReporteRentas.on('click',function(){	
			var id_modulo = 8;
			var params={            
			   xtype:'formReporteRentas',           
			   idValue:0,
			   title:'Reporte de Rentas',
			   closable: true,
			   iconCls: 'tab-pedidos',
			   idReporte:1 //1=Reporte de Rentas
			   
		   };
					
		   this.validarPermisoModulo(id_modulo,params);
		},this);
		
		this.btnGastos.on('click',function(){	
			var id_modulo = 9;
			var params={            
			   xtype:'formGastos',           
			   idValue:0,
			   title:'Gastos',
			   closable: true,
			   iconCls: 'tab-gastos'
		   };
					
		   this.validarPermisoModulo(id_modulo,params);
		},this);
		
		this.btnReporteGastos.on('click',function(){	
			var id_modulo = 10;
			var params={            
			   xtype:'formReporteGastos',           
			   idValue:0,
			   title:'Reporte de Gastos',
			   closable: true,
			   iconCls: 'tab-gastos',
			   idReporte:2 //1=Reporte de Rentas,2=Reporte de Gastos
			   
		   };
					
		   this.validarPermisoModulo(id_modulo,params);
		},this);
		
		this.btnReporteInventario.on('click',function(){	
			var id_modulo = 10;
			var params={            
			   xtype:'formReporteInventario',           
			   idValue:0,
			   title:'Reporte de Inventario',
			   closable: true,
			   iconCls: 'tab-inventarios',
			   idReporte:3 //1=Reporte de Rentas,2=Reporte de Gastos
			   
		   };
					
		   this.validarPermisoModulo(id_modulo,params);
		},this);
		
	
    },
	obtenerInformacionInicial:function(){
		Ext.Ajax.request({
        url: "app.php/sistema/getparametros",
		scope:this,
        success: function(response){            
            var resp=eval ('('+response.responseText+")");
            
			
			eNuevoOriente.parametros=resp.Parametros;
            eNuevoOriente.parametros.registros_pagina=parseInt(eNuevoOriente.parametros.registros_pagina);
            eNuevoOriente.User=resp.User;
			eNuevoOriente.UserConfig=resp.UserConfig;
           			
			this.actualizarHeader(resp);
		
        },
        failure: function(response){
			Ext.Msg.alert("Error en el servidor","No se recibieron los parámetros de configuración");            
        }
    });
	},
	actualizarHeader: function (data){
		
			this.lblNombreUsuario.setValue(data.User.nombre_usuario+' | '+data.User.correo);
			
              
	},
	cargarTab:function(params,esBuscador){
			
			esBuscador=esBuscador||false;
			
			if (params.xtype==undefined){
				Ext.Msg.show({
				   title:'El Módulo está desabilitado',
				   msg: 'Consulte al Administrador del Sistema',
				   buttons: Ext.Msg.OK,
				   animEl: 'elId',
				   icon: Ext.MessageBox.INFO
				});  
				return;
			}			
			
			var tabItems = this.tabContainer.items;
			var existe = false;
			var tab;
			var tabId;
			var i;
			for (i=0; i<tabItems.getCount(); i++){
				tab = tabItems.items[i];
				
				if (tab.tabIdValue==undefined){
					tabId=tab.idValue;
				}else{
					tabId=tab.tabIdValue;
				}
			
				if (tab.xtype == params.xtype && tabId == params.idValue){
					this.tabContainer.setActiveTab(tab);     //<-------SI EXISTE LO MUESTRO DANDOLE EL FOCO
					existe = true;
					break;
				}
			
			}			
			
			 if (!existe){
				 
				var accion='';
				if (params.bullet==undefined){
					accion=(params.idValue==0)? 'add':'edit';
				}else{
					accion=params.bullet;
				}
				
				var iconCls= Ext.ux.TDGi.iconMgr.getIcon(params.iconMaster);
				
				tab=this.tabContainer.add(Ext.applyIf(params,{
					title:'loading',
					iconCls:iconCls,
					closable: true
				}));
			}
			/*-------------------------------------------------------------*/        
			tab.show();		               
			return tab; 
			
			
	},
	cerrarTodos: function () {
        var tamanio = this.tabContainer.items.length;
        for (var $i = tamanio - 1; $i > 0; $i--) {
           this.tabContainer.remove(this.tabContainer.items.items[$i]);
        }
        
        this.tabContainer.setActiveTab(0);
    },
	validarPermisoModulo: function (id, params){		
		var conPermiso = false;
		
		var param={            
		   id_usuario: eNuevoOriente.User.id_usuario,           
		   id_modulo: id,
		   rol: eNuevoOriente.User.rol
		 };
		 
		Ext.Ajax.request({
			params: param,
			scope:this,
		   	url: 'app.php/sistema/validarpermisomodulo',
		   	success: function(response,options){	
				var respuesta=Ext.decode(response.responseText);				
				if(respuesta.permiso == true){					
					var tab=MainContainer.cargarTab(params);
				}else{
					Ext.Msg.alert("Error","No tiene permisos a este modulo");					
				}
				
				
		   	},
		   	failure: function(){
		   		Ext.Msg.alert("Error","Error al realizar la peticion");  
		   	}		   
		});
		
		
	}
});
Ext.reg('eno.Main', eno.Main);
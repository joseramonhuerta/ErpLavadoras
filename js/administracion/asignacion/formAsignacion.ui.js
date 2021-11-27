formAsignacionUi = Ext.extend(Ext.Panel, {
    width: 1252,
    layout: 'card',
    activeItem: 0,
    initComponent: function() {
		
        this.items = [
            {
				xtype: 'tabpanel',
				activeTab: 0,
				height: 320,
				ref: 'tabAsignaciones',
				itemId: 'tabAsignaciones',
				style: 'padding:10px;', 
				items: [
					{
						xtype: 'panel',
						title: 'Nueva Asignacion',
						style: 'padding-left:0;border-width:1px 1px 0px 1px;',
                        bodyStyle: 'padding-left:10px;',
						hideBorders: true,
						border: false,
						iconCls: 'tab-asignacion-nuevo',
						items:[
							{
								xtype: 'form',
								itemId: 'formAsignacion',
								border: false,
								ref: '../../formAsignacion',
								padding: 10,
								items: [
									{
										xtype: 'toolbar',
										items: [
											{
												xtype: 'button',
												text: 'Guardar',
												itemId: 'btnGuardar',
												icon: 'images/iconos/group_add.png',
												ref: '../../../../btnGuardar'
											},
											{
												xtype: 'tbseparator'
											},
											{
												xtype: 'button',
												text: 'Cancelar',
												itemId: 'btnCancelar',
												icon: 'images/iconos/group_delete.png',
												ref: '../../../../btnCancelar'
											}
										]
									},
									{
										
										xtype: 'fieldset',
										title: 'Trabajador',
										height: 100,
										width: 900,
										items: [
											{	
												xtype: 'container',
												layout: 'hbox',
												items:[
													{
														xtype: 'container',
														flex: 1,
														layout: 'form',
														items: [
															{
																xtype: 'datefield',
																itemId: 'txtFecha',
																name: 'fecha',
																hidden: true,
																ref: '../../../../../../txtFecha'
															},
															{
																xtype: 'combo',
																fieldLabel: 'Trabajador',
																width: 300,
																itemId: 'cmbTrabajador',
																name: 'id_trabajador',
																valueField: 'id_trabajador',
																displayField: 'nombre_trabajador',
																allowBlank: false,
																forceSelection: true,
																enableKeyEvents: true,
																labelStyle: 'font-weight:bold',
																minChars: 0,
																pageSize: 20,
																triggerConfig: {
																	tag: 'span',
																	cls: 'x-form-twin-triggers',
																	style: 'padding-right:2px',
																	cn: [
																		{
																			tag: "img",
																			src: Ext.BLANK_IMAGE_URL,
																			cls: "x-form-trigger x-form-clear-trigger"
																		},
																		{
																			tag: "img",
																			src: Ext.BLANK_IMAGE_URL,
																			cls: "x-form-trigger x-form-search-trigger"
																		}
																	]
																},
																ref: '../../../../../../cmbTrabajador'
															}
														]	
													}															
												
												]
											
											},
											{
												xtype: 'container',
												layout: 'hbox',
												items:[
													{
														xtype: 'container',
														flex: 1,
														layout: 'form',
														width: 200,
														items: [
															{
																
																xtype: 'textfield',
																fieldLabel: 'Ruta',
																itemId: 'txtRuta',
																name: 'ruta',
																width: 100,
																submitValue: false,
																disabled: true,
																ref: '../../../../../../txtRuta'
															
																
																
															}
														]	
													},	
													{
														xtype: 'container',														
														width: 10
													},
													{
														xtype: 'textfield',
														fieldLabel: 'Chofer Ruta',
														itemId: 'txtChofer',
														name: 'chofer',
														width: 250,
														submitValue: false,
														disabled: true,
														ref: '../../../../../txtChofer'
													}
												
												]
											}
										
										]
										
										
									},
									{
										
										xtype: 'fieldset',
										title: 'Producto',
										height: 100,
										width: 900,
										items: [
											{
												xtype: 'container',
												//flex: 1,
												layout: 'form',
												items: [
													{
														 xtype: 'combo',
														fieldLabel: 'Producto',
														width: 300,
														labelStyle: 'font-weight:bold;',
														allowBlank: false,
														forceSelection: true,
														hiddenName: 'id_producto',
														name: 'id_producto',
														displayField: 'descripcion',
														valueField: 'id_producto',
														enableKeyEvents: true,
														pageSize: 20,
														triggerAction: 'all',
														minChars: 2,
														triggerConfig: {
															tag: 'span',
															cls: 'x-form-twin-triggers',
															style: 'padding-right:2px',
															cn: [
																{
																	tag: "img",
																	src: Ext.BLANK_IMAGE_URL,
																	cls: "x-form-trigger x-form-clear-trigger"
																},
																{
																	tag: "img",
																	src: Ext.BLANK_IMAGE_URL,
																	cls: "x-form-trigger x-form-search-trigger"
																}
															]
														},
														ref: '../../../../../cmbProducto'
													}
												]
														
											}
										
										]
										
										
									}
								]
							}					
						
						]
						
						
					},
					{
						xtype: 'panel',
						title: 'Asignadas a Trabajadores',
						style: 'padding-left:0;border-width:1px 1px 0px 1px;',
                         //      bodyStyle: 'padding-left:10px;',
						hideBorders: true,
						 layout: 'card',
						activeItem: 0,
						ref: '../tab_asignadas',
						itemId: 'tab_asignadas',
						border: false,						
						iconCls: 'tab-asignadas-registro',
						items: [
							{
								xtype: 'container',
								padding: 10,
								layout: 'border',
								//border: false,
								items:[
									
									{
										xtype: 'grid',
										region: 'center',
										//width: 600,
										height: 500,
										itemId: 'gridAsignados',
										ref: '../../../gridAsignados',
										store: 'storeGridAsignacion',
										stripeRows: true,
										autoExpandColumn: 'colNombre',
										tbar: {
											xtype: 'toolbar',
											items: [
												{
													xtype: 'button',
													text: 'Actualizar',
													ref: '../../../../../btnActualizar',
													icon: 'images/iconos/undo.png'
												},
												{
													xtype: 'tbseparator'
												},
												{
													xtype: 'button',
													text: 'Regresar a bodega',
													disabled: true,
													ref: '../../../../../btnRegresarBodega',
													icon: 'images/iconos/movimientos_almacen.png',
												},
												{
													xtype: 'tbfill'
												},
												{
													xtype: 'textfield',
													emptyText: 'Introduzca el texto a buscar',
													width: 250,
													ref: '../../../../../txtFiltro'
												}
											]
										},
										columns: [
											{
												xtype: 'gridcolumn',
												dataIndex: 'fecha',
												header: 'Fecha',
												sortable: true,
												width: 100
											},
											
											{
												xtype: 'gridcolumn',
												dataIndex: 'nombre_trabajador',
												header: 'Nombre Trabajador',
												sortable: true,
												width: 200,
												id: 'colNombre'
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'descripcion',
												header: 'Producto',
												sortable: true,
												width: 200
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'status_asignacion',
												header: 'Estatus Pedido',
												sortable: true,
												width: 150
											}
											
										],
										view: new Ext.grid.GridView({
											
										}),
										bbar: {
											xtype: 'paging',
											displayInfo: true
										}
										
									}
								]
							
							}
						
						
						]
						
					}
				
				]
			
				
			}
		];
        formAsignacionUi.superclass.initComponent.call(this);
    }
});			
formPedidosUi = Ext.extend(Ext.Panel, {
    width: 1252,
    layout: 'card',
    activeItem: 0,
    initComponent: function() {
		
        this.items = [
            {
				xtype: 'tabpanel',
				activeTab: 0,
				height: 320,
				ref: 'tabPedidos',
				itemId: 'tabPedidos',
				style: 'padding:10px;', 
				items: [
					{
						xtype: 'panel',
						title: 'Nuevo Pedido',
						style: 'padding-left:0;border-width:1px 1px 0px 1px;',
                        bodyStyle: 'padding-left:10px;',
						hideBorders: true,
						border: false,
						iconCls: 'tab-pedidos-nuevo',
						items:[
							{
								xtype: 'form',
								itemId: 'formPedidos',
								border: false,
								ref: '../../formPedidos',
								padding: 10,
								items: [
									{
										xtype: 'toolbar',
										items: [
											{
												xtype: 'button',
												text: 'Guardar',
												itemId: 'btnGuardar',
												icon: 'images/iconos/facturas_add.png',
												ref: '../../../../btnGuardar'
											},
											{
												xtype: 'tbseparator'
											},
											{
												xtype: 'button',
												text: 'Cancelar',
												itemId: 'btnCancelar',
												icon: 'images/iconos/facturas_delete.png',
												ref: '../../../../btnCancelar'
											}
										]
									},
									{
										
										xtype: 'fieldset',
										title: 'Cliente',
										height: 150,
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
																xtype: 'combo',
																fieldLabel: 'Cliente',
																width: 300,
																itemId: 'cmbCliente',
																name: 'id_cliente',
																valueField: 'id_cliente',
																displayField: 'nombre',
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
																ref: '../../../../../../cmbCliente'
															},
															{
																xtype: 'textfield',
																fieldLabel: 'Colonia',
																itemId: 'txtColonia',
																name: 'colonia',
																width: 300,
																submitValue: false,
																//onlyRead: true,
																ref: '../../../../../../txtColonia'
															},
															{
																xtype: 'textfield',
																fieldLabel: 'Direccion',
																itemId: 'txtCalle',
																name: 'calle',
																width: 300,
																submitValue: false,
																//disabled: true,
																ref: '../../../../../../txtCalle'
															}
														]	
													},
													{
														xtype: 'container',
														flex: 1,
														layout: 'form',
														items: [
															{
																 xtype: 'combo',
																fieldLabel: 'Ruta',
																width: 160,
																labelStyle: 'font-weight:bold;',
																allowBlank: false,
																forceSelection: true,
																hiddenName: 'id_ruta',
																name: 'id_ruta',
																displayField: 'descripcion',
																valueField: 'id_ruta',
																enableKeyEvents: true,
																pageSize: 20,
																triggerAction: 'all',
																minChars: 2,
																
																ref: '../../../../../../cmbRuta'
																
																
															},
															{
																xtype: 'textfield',
																itemId: 'txtIdTrabajador',
																name: 'IdTrabajador',
																hidden: true,
																width: 300,
																submitValue: false,
																ref: '../../../../../../txtIdTrabajador'
															},
															{
																 xtype: 'combo',
																fieldLabel: 'Chofer Ruta',
																width: 250,
																labelStyle: 'font-weight:bold;',
																allowBlank: false,
																forceSelection: true,
																hiddenName: 'id_trabajador',
																name: 'id_trabajador',
																displayField: 'nombre_trabajador',
																valueField: 'id_trabajador',
																enableKeyEvents: true,
																pageSize: 20,
																triggerAction: 'all',
																minChars: 2,
																
																ref: '../../../../../../txtChofer'
															},
															/*{
																xtype: 'textfield',
																fieldLabel: 'Chofer Ruta',
																itemId: 'txtChofer',
																name: 'chofer',
																width: 300,
																submitValue: false,
																ref: '../../../../../../txtChofer'
															},*/
															{
																xtype: 'textfield',
																fieldLabel: 'Referencia',
																itemId: 'txtReferencia',
																name: 'referencia',
																width: 300,
																//labelStyle: 'font-weight:bold',
																//submitValue: false,
																ref: '../../../../../../txtReferencia'
															}
														]	
													}		
												
												]
											
											}
										
										]
										
										
									},
									{
										
										xtype: 'fieldset',
										title: 'Detalles Pedido',
										height: 200,
										width: 900,
										items: [
											{	
												xtype: 'container',
												layout: 'hbox',
												items:[
													{
														xtype: 'container',
														flex: 1,
														layout: 'hbox',
														items: [															
															{
																xtype: 'container',
																layout: 'form',
																labelAlign: 'top',
																items: [															
																	{
																		xtype: 'datefield',
																		fieldLabel: 'Fecha Entrega',
																		itemId: 'txtFechaEntrega',
																		name: 'fecha',
																		width: 100,
																		labelStyle: 'font-weight:bold',												
																		ref: '../../../../../../../txtFechaEntrega'
																	}
																]
															},
															{
																xtype: 'container',
																width: 10
																
															},
															{
																xtype: 'container',
																layout: 'form',
																labelAlign: 'top',
																items: [															
																	{
																		xtype: 'timefield',
																		fieldLabel: 'Hora Entrega',
																		itemId: 'txtHoraEntrega',
																		name: 'hora',
																		width: 100,
																		format: 'g:i:s A',
																		labelStyle: 'font-weight:bold',												
																		ref: '../../../../../../../txtHoraEntrega'
																	}
																]
															},
															{
																xtype: 'container',
																width: 10
																
															},
															{
																xtype: 'container',
																layout: 'form',
																labelAlign: 'top',
																items: [															
																	{
																		xtype: 'combo',
																		fieldLabel: 'Plazo Pago',
																		width: 100,
																		labelStyle: 'font-weight:bold;',
																		allowBlank: false,
																		forceSelection: true,
																		name: 'plazo_pago',
																		displayField: 'nombre',
																		valueField: 'id',
																		mode: 'local',
																		triggerAction: 'all',
																		hiddenName: 'plazo_pago',
																		editable: false,
																		ref: '../../../../../../../cmbPlazoPago'
																	}
																]
															},
															{
																xtype: 'container',
																width: 5
																
															},
															{
																xtype: 'container',
																layout: 'form',
																labelAlign: 'top',
																items: [															
																	{
																		xtype: 'numberfield',
																		fieldLabel: 'Precio Renta',
																		itemId: 'txtPrecioRenta',
																		name: 'precio_renta',
																		width: 100,
																		allowNegative: false,
																		allowBlank: false,
																		style: 'text-align:right;',
																		labelStyle: 'font-weight:bold',												
																		ref: '../../../../../../../txtPrecioRenta'
																	}
																]
															}
														]	
													},
													{
														xtype: 'container',
														flex: 1,
														layout: 'form',
														labelAlign: 'top',
														items: [
															{
																xtype: 'textarea',
																fieldLabel: 'Observaciones',
																itemId: 'txtObservaciones',
																name: 'observaciones',
																width: 400,
																labelStyle: 'font-weight:bold',
																ref: '../../../../../../txtObservaciones'
															}
														]	
													}		
												
												]
											
											},
											{
												xtype: 'container',
												layout: 'hbox',
												items: [
													{
														xtype: 'container',
														//flex: 1,
														layout: 'form',
														labelAlign: 'top',
														items: [
															{
																 xtype: 'combo',
																fieldLabel: 'Trabajador temporal (Ocacional)',
																width: 250,
																labelStyle: 'font-weight:bold;',
																allowBlank: false,
																forceSelection: true,
																hiddenName: 'id_trabajador_ocacional',
																name: 'id_trabajador_ocacional',
																displayField: 'nombre_trabajador',
																valueField: 'id_trabajador',
																enableKeyEvents: true,
																pageSize: 20,
																triggerAction: 'all',
																minChars: 2,
																
																ref: '../../../../../../cmbTrabajador'
															}
														]
													},
													{
																xtype: 'container',
																width: 5
																
													},
													{
														xtype: 'container',
														//flex: 1,
														layout: 'form',
														labelAlign: 'top',
														items: [
															{
																xtype: 'textfield',
																fieldLabel: 'Ruta',
																itemId: 'txtRuta',
																name: 'ruta',
																width: 100,
																labelStyle: 'font-weight:bold',												
																ref: '../../../../../../txtRuta'
															}
														]
													},
													{
																xtype: 'container',
																width: 10
																
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
						title: 'Registros de Pedidos',
						style: 'padding-left:0;border-width:1px 1px 0px 1px;',
                         //      bodyStyle: 'padding-left:10px;',
						hideBorders: true,
						 layout: 'card',
						activeItem: 0,
						ref: '../tab_pedidos',
						itemId: 'tab_pedidos',
						border: false,						
						iconCls: 'tab-pedidos-registro',
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
										itemId: 'gridPedidos',
										ref: '../../../gridPedidos',
										store: 'storeGridPedidos',
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
													text: 'Editar',
													disabled: true,
													ref: '../../../../../btnEditar',
													icon: 'images/iconos/facturas_edit.png',
												},
												{
													xtype: 'tbseparator'
												},
												{
													xtype: 'button',
													text: 'Cancelar',
													disabled: true,
													ref: '../../../../../btnCancelarPedido',
													icon: 'images/iconos/facturas_delete.png'
												},
												{
													xtype: 'tbseparator'
												},
												{
													xtype: 'button',
													text: 'Autorizar',
													disabled: true,
													ref: '../../../../../btnAutorizarPedido',
													icon: 'images/iconos/autorizar.png'
												},
												{
													xtype: 'tbfill'
												},
												{
													xtype: 'displayfield',
													value: 'Status:',
													style: 'margin-right:5px;'
												},
												{
													xtype: 'combo',
													triggerAction: 'all',
													mode: 'local',
													displayField: 'nombre',
													valueField: 'id',
													width: 100,
													forceSelection: true,
													allowBlank: false,
													name: 'status_pedido',
													hiddenName: 'status_pedido',
													itemId: 'cmbStatusPedido',
													style: '',
													editable: false,
													ref: '../../../../../cmbStatusPedido'
												},
												{
													xtype: 'tbseparator',
													style: ''
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
												dataIndex: 'fecha_entrega',
												header: 'Fecha Entrega',
												sortable: true,
												width: 100
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'hora_entrega',
												header: 'Hora Entrega',
												sortable: true,
												width: 100
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'nombre_cliente',
												header: 'Nombre Cliente',
												sortable: true,
												width: 200,
												id: 'colNombre'
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'calle',
												header: 'Calle',
												sortable: true,
												width: 200
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'colonia',
												header: 'Colonia',
												sortable: true,
												width: 120
											},
											
											{
												xtype: 'gridcolumn',
												dataIndex: 'celular',
												header: 'Celular',
												sortable: true,
												width: 100
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'precio_renta',
												header: 'Precio Renta',
												sortable: true,
												align: 'right',
												width: 150
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'observaciones',
												header: 'Observaciones',
												sortable: true,
												width: 150
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'nombre_trabajador_ocacional',
												header: 'Chofer',
												sortable: true,
												width: 100
											},
											{
												xtype: 'gridcolumn',
												sortable: true,
												resizable: false,
												width: 25,
												dataIndex: 'status_entrega',
												editable: false,
												align: 'center',
												id: 'colStatusEntrega'
											},
											{
												xtype: 'gridcolumn',
												sortable: true,
												resizable: false,
												width: 25,
												dataIndex: 'autorizada',
												editable: false,
												align: 'center',
												id: 'colAutorizada'
											},
											{
												xtype: 'gridcolumn',
												sortable: true,
												resizable: false,
												width: 25,
												dataIndex: 'origen',
												editable: false,
												align: 'center',
												id: 'colOrigen'
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
        formPedidosUi.superclass.initComponent.call(this);
    }
});			
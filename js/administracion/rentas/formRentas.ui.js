formRentasUi = Ext.extend(Ext.Panel, {
    width: 1252,
    layout: 'card',
    activeItem: 0,
    initComponent: function() {
		
        this.items = [
            {
				xtype: 'tabpanel',
				activeTab: 0,
				height: 320,
				ref: 'tabRentas',
				itemId: 'tabRentas',
				style: 'padding:10px;', 
				items: [
					{
						xtype: 'panel',
						title: 'Registros de Rentas',
						style: 'padding-left:0;border-width:1px 1px 0px 1px;',
                         //      bodyStyle: 'padding-left:10px;',
						hideBorders: true,
						 layout: 'card',
						activeItem: 0,
						ref: '../tab_rentas',
						itemId: 'tab_rentas',
						border: false,						
						iconCls: 'tab-rentas-registro',
						tbar: {
								xtype: 'toolbar',
								items: [
									{
										xtype: 'button',
										text: 'Editar',
										disabled: true,
										ref: '../../../btnEditar',
										icon: 'images/iconos/facturas_edit.png',
									},
									{
										xtype: 'tbseparator'
									},
									{
										xtype: 'button',
										text: 'Cancelar',
										disabled: true,
										ref: '../../../btnCancelarPedido',
										icon: 'images/iconos/facturas_delete.png'
									},
									{
										xtype: 'tbseparator'
									},
									{
										xtype: 'button',
										text: 'Agregar Pago',
										disabled: true,
										ref: '../../../btnAgregarPago',
										icon: 'images/iconos/ordven_add.png',
									},
									{
										xtype: 'tbseparator'
									},
									{
										xtype: 'button',
										text: 'Ver Pagos',
										disabled: true,
										ref: '../../../btnVerPagos',
										icon: 'images/iconos/ordven.png',
									},
									{
										xtype: 'tbseparator'
									},
									{
										xtype: 'button',
										text: 'Agregar Dias Extra',
										disabled: true,
										ref: '../../../btnAgregarDiasExtra',
										icon: 'images/iconos/calendar.png',
									},
									{
										xtype: 'tbseparator'
									},
									{
										xtype: 'button',
										text: 'Reimprime Recibo',
										disabled: true,
										ref: '../../../btnReimprime',
										icon: 'images/iconos/ticket.png',
									},
									{
										xtype: 'tbseparator'
									},
									{
										xtype: 'button',
										text: 'Entrega Anticipada',
										disabled: true,
										ref: '../../../btnEntregaAnticipada',
										icon: 'images/iconos/back.png',
									},
									{
										xtype: 'tbfill'
									},
									
									{
										xtype: 'textfield',
										emptyText: 'Introduzca el texto a buscar',
										width: 250,
										ref: '../../../txtFiltro'
									}
									
								]
							},
						items: [
							{
								xtype: 'container',
								padding: 10,
								layout: 'border',
								//border: false,
								
								items:[
									
									{
										xtype: 'panel',
										height: 60,
										region: 'north',
										padding: 10,
										items:[
											{
												xtype: 'container',
												layout: 'hbox',
												items:[
													{
														xtype: 'container',
														layout: 'form',
														labelAlign: 'top',
														items:[
															{
																xtype: 'datefield',
																fieldLabel: 'Fecha Inicio',
																itemId: 'txtFechaInicio',
																name: 'fechainicio',
																allowBlank: false,
																width: 100,
																disabled:true,
																labelStyle: 'font-weight:bold',												
																ref: '../../../../../../txtFechaInicio'
																
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
														items:[
															{
																xtype: 'datefield',
																fieldLabel: 'Fecha Fin',
																itemId: 'txtFechaFin',
																name: 'fechafin',
																allowBlank: false,
																disabled:true,
																width: 100,
																labelStyle: 'font-weight:bold',												
																ref: '../../../../../../txtFechaFin'
																
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
														items:[
															{
																xtype: 'checkbox',
																fieldLabel: '',
																itemId: 'chkFechas',
																name: 'filtroFechas',
																ref: '../../../../../../chkFechas'
																
															}
														]
													},
													{
														xtype: 'container',
														width: 10
														
														
													},/*
													{
														xtype: 'container',
														layout: 'form',														
														items:[
															{
																xtype: 'checkbox',
																fieldLabel: '',
																itemId: 'chkFechas',
																name: 'fechafin',
																width: 100,
																boxLabel: 'Filtrar por fecha',								
																ref: '../../../../../../chkFechas'
																
															}
														]
													},
													{
														xtype: 'container',
														width: 10
														
														
													},*/
													{
														xtype: 'container',
														layout: 'form',
														labelAlign: 'top',
														items:[
															{
																xtype: 'combo',
																fieldLabel: 'Cliente',
																width: 300,
																itemId: 'cmbCliente',
																name: 'id_cliente',
																valueField: 'id_cliente',
																displayField: 'nombre',
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
														items:[
															{
																 xtype: 'combo',
																fieldLabel: 'Cobrador',
																width: 250,
																labelStyle: 'font-weight:bold;',
																hiddenName: 'id_trabajador',
																name: 'id_trabajador',
																displayField: 'nombre_trabajador',
																valueField: 'id_trabajador',
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
																ref: '../../../../../../cmbTrabajador'
																
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
														items:[
															{
																xtype: 'combo',
																fieldLabel: 'Estatus Renta',
																triggerAction: 'all',
																mode: 'local',
																displayField: 'nombre',
																valueField: 'id',
																width: 150,
																forceSelection: true,
																allowBlank: false,
																name: 'status_renta',
																hiddenName: 'status_renta',
																itemId: 'cmbStatusRenta',
																style: '',
																editable: false,
																ref: '../../../../../../cmbStatusRenta'
																
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
														items:[
															{
																xtype: 'button',
																ref: '../../../../../../btnActualizar',
																icon: 'images/iconos/undo.png',
																style: 'margin-top: 18px'
																
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
														//labelAlign: 'top',
														items:[
															{
																xtype: 'button',
																text: 'Cobradas',
																ref: '../../../../../../btnCobradas',
																allowDepress: true,
																enableToggle: true,
																icon: 'images/iconos/ordven.png',
																style: 'margin-top: 18px'
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
														//labelAlign: 'top',
														items:[
															{
																xtype: 'button',
																text: 'Recogidas',
																ref: '../../../../../../btnRecogidas',
																allowDepress: true,
																enableToggle: true,
																icon: 'images/iconos/box.png',
																style: 'margin-top: 18px'
															}
														]
													}
												]
												
												
											}
										]
									},
									{
										xtype: 'grid',
										region: 'center',
										//width: 600,
										height: 500,
										itemId: 'gridRentas',
										ref: '../../../gridRentas',
										store: 'storeGridRentas',
										stripeRows: true,
										autoExpandColumn: 'colCalle',
										
										columns: [
											{
												xtype: 'gridcolumn',
												sortable: true,
												resizable: false,
												width: 25,
												dataIndex: 'status_renta',
												editable: false,
												align: 'center',
												id: 'colStatusRenta'
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'fecha_entrega',
												header: 'Fecha',
												sortable: true,
												width: 120
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'fecha_entrega_cliente',
												header: 'Fecha Entrega',
												sortable: true,
												width: 120
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'fecha_ultimo_vencimiento',
												header: 'Fecha Ult. Venc.',
												sortable: true,
												width: 95
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'id_ultimo_pago',
												header: 'Ult. Recibo',
												sortable: true,
												width: 70
											},											
											{
												xtype: 'gridcolumn',
												dataIndex: 'fecha_ultimo_pago',
												header: 'Fecha Ult. Pago',
												sortable: true,
												width: 95
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'fecha_recogida',
												header: 'Fecha Recogida',
												sortable: true,
												width: 95
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'dias_renta',
												header: 'Dias',
												sortable: true,
												width: 50
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
												width: 200,
												id: 'colCalle'
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
												dataIndex: 'descripcion',
												header: 'Producto',
												sortable: true,
												width: 150
											},
											{
												xtype: 'gridcolumn',
												dataIndex: 'precio_renta',
												header: 'Precio Renta',
												align: 'right',
												sortable: true,
												width: 90
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
        formRentasUi.superclass.initComponent.call(this);
    }
});			